<?php

namespace spec\Akeneo\Pim\Enrichment\Component\Product\Normalizer\Standard\Product;

use Akeneo\Pim\Enrichment\Component\Product\Normalizer\Standard\Product\ProductValuesNormalizer;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Akeneo\Pim\Structure\Component\Model\Attribute;
use Akeneo\Pim\Structure\Component\Model\AttributeInterface;
use Akeneo\Pim\Enrichment\Component\Product\Value\ScalarValue;
use Akeneo\Pim\Enrichment\Component\Product\Model\ValueCollection;
use Akeneo\Pim\Enrichment\Component\Product\Model\ValueCollectionInterface;
use Akeneo\Pim\Enrichment\Component\Product\Model\ValueInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ProductValuesNormalizerSpec extends ObjectBehavior
{
    function let(SerializerInterface $serializer)
    {
        $serializer->implement(NormalizerInterface::class);
        $this->setSerializer($serializer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ProductValuesNormalizer::class);
    }

    function it_is_a_normalizer()
    {
        $this->shouldImplement(NormalizerInterface::class);
        $this->shouldBeAnInstanceOf(SerializerAwareInterface::class);
    }

    function it_supports_standard_format_and_collection_values()
    {
        $attribute = new Attribute();
        $attribute->setCode('attribute');
        $attribute->setBackendType('text');
        $realValue = new ScalarValue($attribute, null, null, null);

        $valuesCollection = new ValueCollection([$realValue]);
        $valuesArray = [$realValue];
        $emptyValuesCollection = new ValueCollection();
        $randomCollection = new ArrayCollection([new \stdClass()]);
        $randomArray = [new \stdClass()];

        $this->supportsNormalization($valuesCollection, 'standard')->shouldReturn(true);
        $this->supportsNormalization($valuesArray, 'standard')->shouldReturn(false);
        $this->supportsNormalization($emptyValuesCollection, 'standard')->shouldReturn(true);
        $this->supportsNormalization($randomCollection, 'standard')->shouldReturn(false);
        $this->supportsNormalization($randomArray, 'standard')->shouldReturn(false);
        $this->supportsNormalization(new \stdClass(), 'standard')->shouldReturn(false);
        $this->supportsNormalization($valuesCollection, 'other_format')->shouldReturn(false);
        $this->supportsNormalization(new \stdClass(), 'other_format')->shouldReturn(false);
    }

    function it_normalizes_collection_of_product_values_in_standard_format(
        $serializer,
        ValueInterface $textValue,
        AttributeInterface $text,
        ValueInterface $priceValue,
        AttributeInterface $price,
        ValueCollectionInterface $values,
        \ArrayIterator $valuesIterator
    ) {
        $values->getIterator()->willReturn($valuesIterator);
        $valuesIterator->rewind()->shouldBeCalled();
        $valuesIterator->valid()->willReturn(true, true, false);
        $valuesIterator->current()->willReturn($textValue, $priceValue);
        $valuesIterator->next()->shouldBeCalled();

        $textValue->getAttribute()->willReturn($text);
        $priceValue->getAttribute()->willReturn($price);
        $text->getCode()->willReturn('text');
        $price->getCode()->willReturn('price');

        $serializer
            ->normalize($textValue, 'standard', [])
            ->shouldBeCalled()
            ->willReturn(['locale' => null, 'scope' => null, 'value' => 'foo']);

        $serializer
            ->normalize($priceValue, 'standard', [])
            ->shouldBeCalled()
            ->willReturn(['locale' => 'en_US', 'scope' => 'ecommerce', 'value' => [
                ['amount' => '12.50', 'currency' => 'USD'],
                ['amount' => '15.00', 'currency' => 'EUR']
            ]]);

        $this
            ->normalize($values, 'standard')
            ->shouldReturn(
                [
                    'text' => [
                        ['locale' => null, 'scope' => null, 'value' => 'foo']
                    ],
                    'price' => [
                        ['locale' => 'en_US', 'scope' => 'ecommerce', 'value' => [
                            ['amount' => '12.50', 'currency' => 'USD'],
                            ['amount' => '15.00', 'currency' => 'EUR']
                        ]]
                    ]
                ]
            );
    }
}
