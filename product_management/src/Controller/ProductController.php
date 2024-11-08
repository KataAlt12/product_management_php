<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ProductController extends AbstractController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @Route("/products", name="get_products", methods={"GET"})
     */
    public function getAllProducts(): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        return $this->json($products, 200);
    }

    /**
     * @Route("/products/{id}", name="get_product", methods={"GET"})
     */
    public function getProduct(int $id): JsonResponse
    {
        $product = $this->productService->getProduct($id);

        if ($product) {
            return $this->json($product, 200);
        }

        return $this->json(['message' => 'Product not found'], 404);
    }

    /**
     * @Route("/products", name="create_product", methods={"POST"})
     */
    public function createProduct(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $productData = $request->getContent();

        $product = $serializer->deserialize($productData, Product::class, 'json', [
            AbstractNormalizer::GROUPS => ['product_write'], 
            AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
            DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s', // Assurez-vous du bon format de date
        ]);

        $this->productService->createProduct($product);

        return $this->json(['message' => 'Product created successfully'], 201);
    }

    /**
     * @Route("/products/{id}", name="update_product", methods={"PATCH"})
     */
    public function updateProduct(int $id, Request $request, SerializerInterface $serializer): JsonResponse
    {
        $productData = $request->getContent();

        $product = $serializer->deserialize($productData, Product::class, 'json', [
            AbstractNormalizer::GROUPS => ['product_write'],
            AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,
            DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s', // Assurez-vous du bon format de date
        ]);

        $updatedProduct = $this->productService->updateProduct($id, $product);

        if ($updatedProduct) {
            return $this->json(['message' => 'Product updated successfully'], 200);
        }

        return $this->json(['message' => 'Product not found'], 404);
    }

    /**
     * @Route("/products/{id}", name="delete_product", methods={"DELETE"})
     */
    public function deleteProduct(int $id): JsonResponse
    {
        $deleted = $this->productService->deleteProduct($id);

        if ($deleted) {
            return $this->json(['message' => 'Product deleted successfully'], 200);
        }

        return $this->json(['message' => 'Product not found'], 404);
    }
}
