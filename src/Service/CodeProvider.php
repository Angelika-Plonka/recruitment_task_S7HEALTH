<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CodeRepository;
use App\Entity\Code;

class CodeProvider
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var CodeRepository */
    protected $codeRepository;

    public function __construct(EntityManagerInterface $entityManager, CodeRepository $codeRepository)
    {
        $this->entityManager = $entityManager;
        $this->codeRepository = $this->entityManager->getRepository(Code::class);
    }

    /** Get a list of codes in a database */
    public function getAllCodes()
    {
        return $this->codeRepository->findAll();
    }

    /**
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

}