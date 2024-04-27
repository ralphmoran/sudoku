<?php

namespace App\Controller;

use App\Service\SudokuValidatorService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SudokuController extends AbstractController
{
    /**
     * @Route("/api/verify", "sudoku_verify")
     */
    public function verify(Request $request)
    {
        /** @var UploadedFile $file */
        $file             = $request->files->get('sudoku');

        $tmpFolder        = $this->getParameter('kernel.project_dir') . '/public/tmp';
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName         = $originalFilename . '-' . uniqid() . '.' . $file->guessExtension();
        $status           = ['valid' => true];
        $code             = 200;

        // Move file
        $file->move($tmpFolder, $fileName);

        // In case of error
        if (! SudokuValidatorService::isSudokuPlusValid($tmpFolder . '/' . $fileName)) {
            $status = ['valid' => false];
            $code = 422;
        }

        // Delete file
        unlink($tmpFolder . '/' . $fileName);

        return $this->json($status, $code);
    }

    /**
     * @Route("/show", "sudoku_show")
     */
    public function show()
    {
        return $this->render('sudoku/form.html.twig');
    }
}
