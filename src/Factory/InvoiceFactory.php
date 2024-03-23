<?php

namespace App\Factory;

use App\Entity\Invoice;
use App\Enum\InvoiceEnum;
use App\Enum\InvoicePaymentMethodeEnum;
use App\Repository\InvoiceRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Invoice>
 *
 * @method        Invoice|Proxy                     create(array|callable $attributes = [])
 * @method static Invoice|Proxy                     createOne(array $attributes = [])
 * @method static Invoice|Proxy                     find(object|array|mixed $criteria)
 * @method static Invoice|Proxy                     findOrCreate(array $attributes)
 * @method static Invoice|Proxy                     first(string $sortedField = 'id')
 * @method static Invoice|Proxy                     last(string $sortedField = 'id')
 * @method static Invoice|Proxy                     random(array $attributes = [])
 * @method static Invoice|Proxy                     randomOrCreate(array $attributes = [])
 * @method static InvoiceRepository|RepositoryProxy repository()
 * @method static Invoice[]|Proxy[]                 all()
 * @method static Invoice[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Invoice[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Invoice[]|Proxy[]                 findBy(array $attributes)
 * @method static Invoice[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Invoice[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class InvoiceFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private readonly SluggerInterface $slugger)
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'amount' => self::faker()->randomFloat(),
            'clientId' => ClientFactory::random(),
            'date' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'description' => self::faker()->paragraph(),
            'paymentMethod' => self::faker()->randomElement(InvoicePaymentMethodeEnum::cases()),
            'status' => self::faker()->randomElement(InvoiceEnum::cases()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this->afterInstantiate(function (Invoice $invoice): void {
            $code = $this->slugger->slug($invoice->getDescription());
            $invoice->setInvoiceCode($code);

            $totalAmount = $invoice->getAmount() + self::faker()->randomFloat();
            $invoice->setTotalAmount($totalAmount);

            $daysToAdd = self::faker()->numberBetween(1, 30);
            $dateInterval = new \DateInterval("P{$daysToAdd}D");

            $paymentDate = $invoice->getDate()->add($dateInterval);

            $invoice->setPaymentDate($paymentDate);

            if ($invoice->getAmount() > $invoice->getTotalAmount()) {
                $invoice->setStatus(InvoiceEnum::PAID);
                $invoice->setAmount($invoice->getTotalAmount());
            }
        });
    }

    protected static function getClass(): string
    {
        return Invoice::class;
    }
}
