<?php
namespace AppBundle\Form;

use AppBundle\Data\CountryList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SeedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Reformat the array of country. The format is ["Indonesia"] => "Indonesia".
        // We don't need the country code.
        $countryArray = array_reduce(CountryList::name(), function($result, $item) {
            $result[$item] = $item;
            return $result;
        }, array());

        // Generate 5 years from the current year
        $years = range(date('Y'), date('Y') + 5);
        $yearChoice = array_reduce($years, function($result, $item) {
            $result[$item] = $item;
            return $result;
        }, array());

        $builder
            ->add('name', TextType::class)
            ->add('category', ChoiceType::class, array(
                'choices' => array(
                    'Herb' => 1,
                    'Vegetable' => 2,
                    'Sprout/Microgreens' => 3,
                    'Fruit' => 4,
                    'Tubber' => 5,
                    'Flower' => 6,
                    'Other' => 7
                )
            ))
            ->add('quantity', IntegerType::class)
            ->add('measurementUnit', ChoiceType::class, array(
                'choices' => array(
                    'Seeds' => 1,
                    'Gramme' => 2,
                    'Kilogramme' => 3,
                    'Lbs' => 4,
                    'Oz' => 5
                )
            ))
            ->add('producerName', TextType::class)
            ->add('originCountry', ChoiceType::class, array(
                'choices' => $countryArray
            ))
            ->add('note', TextareaType::class, array('required' => FALSE))
            ->add('expirationMonth', ChoiceType::class, array(
                'choices' => array(
                    'January' => 'January',
                    'February' => 'February',
                    'March' => 'March',
                    'April' => 'April',
                    'May' => 'May',
                    'June' => 'June',
                    'July' => 'July',
                    'August' => 'August',
                    'September' => 'September',
                    'October' => 'October',
                    'November' => 'November',
                    'December' => 'December'
                )
            ))
            ->add('expirationYear', ChoiceType::class, array(
                'choices' => $yearChoice
            ))
            ->add('germinationRate', NumberType::class, array('scale' => 2))
            ->add('photoUrl', FileType::class, array('required' => FALSE))
            ->add('save', SubmitType::class, array('label' => 'Add Seed'));
    }
}