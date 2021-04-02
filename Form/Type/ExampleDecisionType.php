<?php
namespace MauticPlugin\HelloWorldBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

use Mautic\CoreBundle\Form\Type\SortableListType;
use Mautic\CampaignBundle\Form\Type\CampaignListType;
use MauticPlugin\NisiBundle\Utils\Utils;

class ExampleDecisionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("myparameter", NumberType::class, [
            "label"      => "plugin.helloworld.myparameter",
            "attr"       => ["class" => "form-control"],
            "label_attr" => ["class" => "control-label"],
        ]);
    }
}
