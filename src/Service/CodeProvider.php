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
     */
    public function deleteCodesFromDatabase(string $codes)
    {
        //convert a string given into an array of strings
        $convertCodes = preg_replace('/\s+/', '', $codes);
        $convertCodes = explode(',', $convertCodes);
        print_r($convertCodes);
        foreach ($convertCodes as $convertCode) {
            $codeToDelete = $this->codeRepository->findOneByCode($convertCode);
            if ($codeToDelete !== null) {
                $this->entityManager->remove($codeToDelete);

            };
        }
        $this->entityManager->flush();

    }

}