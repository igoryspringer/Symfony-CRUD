<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Knp\Snappy\Pdf;
use Endroid\QrCode\QrCode;

/**
 * Class DefaultController.
 */
class DefaultController extends Controller
{
    /**
     * @Route("/article/{_locale}", name="article_index", requirements={"_locale"="en|ru"})
     */
    public function indexAction()
    {
        $article = $this->getDoctrine()->getRepository(Article::class);
        $articles = $article->findAll();

        return $this->render('entity/index.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/article/{_locale}/new", name="article_new", requirements={"_locale"="en|ru"})
     *
     * @param Request $request
     *
     * @return string|Response
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('entity/new.html.twig', ['article' => $article, 'form' => $form->createView()]);
    }

    /**
     * @Route("/article/{_locale}/show/{id}", name="article_show", requirements={"_locale"="en|ru"})
     *
     * @param $id
     *
     * @return Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);

        return $this->render('entity/show.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/article/{_locale}/edit/{id}", name="article_edit", requirements={"_locale"="en|ru"})
     *
     * @param $id
     *
     * @return RedirectResponse
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $article = $em->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException('No WTF id '.$id);
        }

        $editForm = $this->createForm(ArticleType::class, $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_index', ['id' => $id]);
        }

        return $this->render('entity/edit.html.twig', ['article' => $article, 'edit_form' => $editForm->createView()]);
    }

    /**
     * @Route("/article/{_locale}/delete/{id}", name="article_delete", requirements={"_locale"="en|ru"})
     *
     * @param $id
     *
     * @return RedirectResponse
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/article/locale/{locale}", name="article_locale")
     *
     * @param Request $request
     * @param string  $locale
     *
     * @return Response
     */
    public function changeLocaleAction(Request $request, string $locale): Response
    {
        $request->getSession()->set('_locale', $locale);

        return $this->redirectToRoute('article_index', ['_locale' => $locale]);
    }

    /**
     * @Route("/xls", name="xls")
     */
    public function xlsHelloWorld()
    {
        $spreadsheet = new Spreadsheet();
        $arrayData = [
            [null, 2010, 2011, 2012],
            ['Q1',   12,   15,   21],
            ['Q2',   56,   73,   86],
            ['Q3',   52,   61,   69],
            ['Q4',   30,   32,   10],
        ];
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $arrayData,
                null,
                'B2'
            );

        $writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');

        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/pdf", name="pdf")
     *
     * @param Pdf $generator
     */
    public function pdfGeneration(Pdf $generator)
    {
        $generator->generate('https://www.facebook.com', '/home/igoryspringer/Загрузки/file.pdf');

        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/qr", name="qr_code").
     */
    public function genratorQRCode()
    {
        $qrCode = new QrCode('https://www.facebook.com/igor.ochkan.5');

        header('Content-Type: '.$qrCode->getContentType());
        $qrCode->writeFile('file:////home/igoryspringer/symfonycrud/public/img/qrcode.png');

        return $this->render('article/qrcode.html.twig', ['qr' => $qrCode]);
    }
}
