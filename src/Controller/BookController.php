<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Book;
use App\Form\BookType;

/**
 * Book controller.
 * @Route("/api", name="api_")
 */
class BookController extends Controller
{
  /**
   * Lists all Books.
   * @Rest\Get("/books")
   *
   * @return array
   */
  public function getBooks()
  {
    $repository = $this->getDoctrine()->getRepository(Book::class);
    $books = $repository->findall();
    return View::create($book, Response::HTTP_OK , []);
  }

  /**
   * Retrieves a Book resource
   * @Rest\Get("/books/{bookId}")
   * 
   * @return array
   */
  public function getBook(int $bookId)
  {
    $book = $this->bookRepository->findById($bookId);
    return View::create($book, Response::HTTP_OK, []);
  }

  /**
   * Create Book.
   * @Rest\Post("/book")
   *
   * @return array
   */
  public function postBook(Request $request)
  {
    $book = new Book();
    $form = $this->createForm(BookType::class, $book);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid())
    {
      $em = $this->getDoctrine()->getManager();
      $em->persist($book);
      $em->flush();
      return View::create($book, Response::HTTP_CREATED , []);
    }
  }

  /**
   * Replaces Book resource
   * @Rest\Put("/books/{bookId}")
   */
  public function putBook(int $bookId, Request $request)
  {
    $book = $this->bookRepository->findById($bookId);
    $form = $this->createForm(BookType::class, $book);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid())
    {
      $em = $this->getDoctrine()->getManager();
      $em->persist($book);
      $em->flush();
      return View::create($book, Response::HTTP_CREATED , []);
    }
  }

  /**
   * Removes a Book resource
   * @Rest\Delete("/books/{BookId}")
   */
  public function deleteBook(int $bookId)
  {
    $book = $this->bookRepository->findById($bookId);
    if ($book) {
        $this->bookRepository->delete($book);
    }
    return View::create([], Response::HTTP_NO_CONTENT);
  }

}