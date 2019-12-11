<?php
/**
 * Created by PhpStorm.
 * User: trashkaloff
 * Date: 25.03.17
 * Time: 14:55.
 */

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ArticleType.
 */
class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'label.article.name',
                'attr' => [
                    'placeholder' => 'Enter name here...',
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'label.article.description',
                'attr' => [
                    'placeholder' => 'Enter description here...',
                ],
            ])
            ->add('created_at', DateTimeType::class, [
                'label' => 'label.article.created_at',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'label.article.submit',
            ])
            ->add('reset', ResetType::class, [
                'label' => 'label.article.reset',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
