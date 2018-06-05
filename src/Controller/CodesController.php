<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Service\CodeProvider;
use Symfony\Component\HttpFoundation\Request;

class CodesController extends Controller
{
    /**
     * @Route("/codes", name="codes")
     */
    public function index(Request $request, CodeProvider $codeProvider)
    {
        if ($request->get('addCodes') === "add") {
            $codeProvider->createAndSaveTenCodesIntoDatabase();

            $this->addFlash(
                'notice',
                'Ten codes was added into database!'
            );
            return $this->redirectToRoute('codes');
        } elseif ($request->get('deleteCodes') === "delete") {
//            echo htmlspecialchars($_POST['codesToDelete']);
            $codeProvider->deleteCodesFromDatabase($request->request->get('codesToDelete'));
        }

        return $this->render('codes/index.html.twig', [
            'codes' => $codeProvider->getAllCodes(),
        ]);
    }
}
