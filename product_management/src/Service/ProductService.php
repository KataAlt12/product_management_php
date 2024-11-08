<?php

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Filesystem\Filesystem;

class ProductService
{
    private string $filePath;
    private Serializer $serializer;
    private Filesystem $filesystem;

    public function __construct()
    {
        // Serializer avec DateTimeNormalizer pour gérer les dates
        $this->serializer = new Serializer(
            [new DateTimeNormalizer(['datetime_format' => 'Y-m-d H:i:s']), new ObjectNormalizer()],
            [new JsonEncoder()]
        );

        $this->filePath = __DIR__ . '/../../data/products.json';
        $this->filesystem = new Filesystem();

        // Créer le fichier JSON s'il n'existe pas
        if (!$this->filesystem->exists($this->filePath)) {
            $this->filesystem->dumpFile($this->filePath, '[]');
        }
    }

    public function getAllProducts(): array
    {
        $productsData = file_get_contents($this->filePath);
        return $this->serializer->decode($productsData, 'json');
    }

    public function getProduct(int $id): ?Product
    {
        $products = $this->getAllProducts();

        foreach ($products as $productData) {
            if ($productData['id'] === $id) {
                return $this->serializer->denormalize($productData, Product::class);
            }
        }

        return null;
    }

    public function createProduct(Product $product): void
    {
        $products = $this->getAllProducts();
        
        // Générer un ID unique
        $product->setId($this->generateId($products));

        // Ajout de la date de création et de mise à jour
        $now = new \DateTime();
        $product->setCreatedAt($now);
        $product->setUpdatedAt($now);

        $products[] = $this->serializer->normalize($product, null, ['groups' => 'product_write']);
        file_put_contents($this->filePath, $this->serializer->encode($products, 'json'));
    }

    public function updateProduct(int $id, Product $product): ?Product
    {
        $products = $this->getAllProducts();
        $updated = false;

        foreach ($products as &$productData) {
            if ($productData['id'] === $id) {
                $product->setUpdatedAt(new \DateTime());
                $productData = $this->serializer->normalize($product, null, ['groups' => 'product_write']);
                $updated = true;
                break;
            }
        }

        if ($updated) {
            file_put_contents($this->filePath, $this->serializer->encode($products, 'json'));
            return $product;
        }

        return null;
    }

    public function deleteProduct(int $id): bool
    {
        $products = $this->getAllProducts();
        $initialCount = count($products);

        $products = array_filter($products, function ($productData) use ($id) {
            return $productData['id'] !== $id;
        });

        if (count($products) !== $initialCount) {
            file_put_contents($this->filePath, $this->serializer->encode($products, 'json'));
            return true;
        }

        return false;
    }

    private function generateId(array $products): int
    {
        $ids = array_map(function ($productData) {
            return $productData['id'];
        }, $products);

        return $ids ? max($ids) + 1 : 1;
    }
}
