<?php

namespace Mubiridziri\Crud\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Mubiridziri\Crud\Context\Context;
use Mubiridziri\Crud\Exception\NotOverriddenMethodException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CrudController extends AbstractController implements CrudControllerInterface
{
    /**
     * @return null|object
     * @throws NotOverriddenMethodException
     */
    public static function getEntityName()
    {
        throw new NotOverriddenMethodException(sprintf("Required method %s not overridden", 'getEntityName'));
    }


    public function getDefaultContext(): array
    {
        return [];
    }

    /**
     * @return void
     * @Route("", methods={"GET"})
     */
    public function listAction(Request $request): JsonResponse
    {
        $context = Context::Factory($request);

    }

    /**
     * @return JsonResponse
     * @Route("/{entityId}", methods={"GET"})
     */
    public function detailAction(int $entityId): JsonResponse
    {
        return $this->json($this->getEntityById($entityId), Response::HTTP_OK, [], [
            AbstractNormalizer::GROUPS => ['Detail']
        ] + $this->getDefaultContext());
    }

    /**
     * @return JsonResponse
     * @Route("/", methods={"POST"})
     */
    public function createAction
    (
        SerializerInterface $serializer,
        ValidatorInterface  $validator,
        Request             $request
    ): JsonResponse
    {
        try {
            $entity = $serializer->deserialize($request->getContent(), self::getEntityName(), 'json', [
                AbstractNormalizer::GROUPS => ['Create']
            ]);
            $errors = $validator->validate($entity);
            if ($errors->count() > 0) {
                return $this->json($errors, Response::HTTP_BAD_REQUEST);
            }
            $em = $this->getEntityManager();
            $em->persist($entity);
            $em->flush();
            return $this->json($entity, Response::HTTP_OK, [], [
                AbstractNormalizer::GROUPS => ['View']
            ] + $this->getDefaultContext());
        } catch (NotFoundHttpException $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->json(['error' => "Server error"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return void
     * @Route("/{entityId}", methods={"PUT"})
     */
    public function updateAction
    (
        int                 $entityId,
        SerializerInterface $serializer,
        Request             $request
    ): JsonResponse
    {
        try {
            $entity = $this->getEntityById($entityId);
            $entity = $serializer->deserialize($request->getContent(), self::getEntityName(), 'json', [
                AbstractNormalizer::GROUPS => ['Create'],
                AbstractNormalizer::OBJECT_TO_POPULATE => $entity
            ]);
            $errors = $validator->validate($entity);
            if ($errors->count() > 0) {
                return $this->json($errors, Response::HTTP_BAD_REQUEST);
            }
            $em = $this->getEntityManager();
            $em->persist($entity);
            $em->flush();
            return $this->json($entity, Response::HTTP_OK, [], [
                AbstractNormalizer::GROUPS => ['View']
            ] + $this->getDefaultContext());
        } catch (NotFoundHttpException $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->json(['error' => "Server error"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return void
     * @Route("/{entityId}", methods={"DELETE"})
     */
    public function removeAction(int $entityId): JsonResponse
    {
        try {
            $em = $this->getEntityManager();
            $entity = $this->getEntityById($entityId);
            $em->remove($entity);
            $em->flush();
            return $this->json($entity, Response::HTTP_OK, [], [
                AbstractNormalizer::GROUPS => ['View']
            ] + $this->getDefaultContext());
        } catch (NotFoundHttpException $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->json(['error' => "Server error"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEntityById(int $entityId)
    {
        $em = $this->getEntityManager();
        $entity = $em->getRepository(self::getEntityName())->findOneBy([
            'id' => $entityId
        ]);
        if (!$entity) {
            throw $this->createNotFoundException();
        }
        return $entity;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->container->get('doctrine')->getManager();
    }
}