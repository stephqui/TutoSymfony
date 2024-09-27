<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
  #[Route('/recettes', name: 'recipe.index')]
  public function index(Request $request, RecipeRepository $recipeRepository): Response
  {
    //dd($recipeRepository->findTotalDuration());

    //On veut les recettes dont la durée est inf ou égale à...
    //La méthode est dans le repository
    $recipes = $recipeRepository->findWithDurationLowerThan(40);

    return $this->render('recipe/index.html.twig', [
      'recipes' => $recipes
    ]);
  }
  #[Route('/recette/{slug}-{id}', name: 'recipe.show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
  public function show(Request $request, string $slug, int $id, RecipeRepository $recipeRepository): Response
  {
    $recipe = $recipeRepository->find($id);
    if ($recipe->getSlug() != $slug) {
      return $this->redirectToRoute('recipe.show', ['slug' => $recipe->getSlug(), 'id' => $recipe->getId()]);
    }
    return $this->render('recipe/show.html.twig', [
      'recipe' => $recipe
    ]);
  }

  #[Route('/recette/{id}/edit', name: 'recipe.edit')]
  public function editRecipe(Recipe $recipe, Request $request, EntityManagerInterface $em) {
    $form = $this->createForm(RecipeType::class, $recipe);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $em->flush();
        $this->addFlash('success', 'La recette a bien été modifiée');
        return $this->redirectToRoute('recipe.index');
    }
    return $this->render('recipe/edit.html.twig', [
      'recipe' => $recipe,
      'form'=>$form
    ]);
  }
}
