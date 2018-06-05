<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CodeRepository;
use App\Entity\Code;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CodeProvider
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var CodeRepository */
    protected $codeRepository;

    /** @var SessionInterface */
    protected $session;

    public function __construct(EntityManagerInterface $entityManager, CodeRepository $codeRepository, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->codeRepository = $this->entityManager->getRepository(Code::class);
        $this->session = $session;
    }

    /** Get a list of codes in a database */
    public function getAllCodes()
    {
        return $this->codeRepository->findAll();
    }

    /**
     * create random 10 codes and save them into database
     * @return Code
     */
    public function createAndSaveTenCodesIntoDatabase(): Code
    {
        for ($i = 0; $i < 10; $i++) {
            $randomCode = mt_rand(100000000, 899999999);
            $code = $this->codeRepository->findOneByCode($randomCode);
            if ($code == null) {
                $code = new Code();
                $code->setCode($randomCode);
            } else {
                $randomCode = mt_rand(100000000, 899999999);
                $code = new Code();
                $code->setCode($randomCode);
            }
            $this->entityManager->persist($code);

        }
        $this->entityManager->flush();
        return $code;
    }

    /**
     *delete codes from database but firstly check if code exist in database (if not: throw a notice)
     * @param string
     */
    public function deleteCodesFromDatabase(string $codes)
    {
        //convert a string given into an array of strings
        $convertCodes = preg_replace('/\s+/', '', $codes);
        $convertCodes = explode(',', $convertCodes);
        $codesToDelete = [];

        foreach ($convertCodes as $keyConvertCode => $valConvertCode) {
            $codeToDelete = $this->codeRepository->findOneByCode($valConvertCode);
            $codesToDelete[$valConvertCode] = $codeToDelete;
        }

        foreach ($codesToDelete as $key => $val) {
            $notExistingCodes = [];
            if (is_null($codesToDelete[$key])) {
                $notExistingCodes[] = $key;
                $this->session->getFlashBag()->add(
                    'error',
                    "Not found code {$key}"
                );
            }
        }
        if (count($notExistingCodes) === 0) {
            $this->session->getFlashBag()->add(
                'notice',
                "Codes was deleted"
            );
            foreach ($codesToDelete as $key => $val) {
                $toRemove = $this->codeRepository->findOneByCode($key);
                $this->entityManager->remove($toRemove);
            }
            $this->entityManager->flush();
        }
    }

}