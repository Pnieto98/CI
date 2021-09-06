<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $payment_date;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $company;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $external_reference;

    /**
     * @ORM\Column(type="integer")
     */
    private $terminal;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentMethod::class, inversedBy="payments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $payment_method;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentStatus::class, inversedBy="payments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $payment_status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    private $status;

    private $payment;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->payment_date;
    }

    public function setPaymentDate(\DateTimeInterface $payment_date): self
    {
        $this->payment_date = $payment_date;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getAmount(): ?float
    {
        #SI EL MONTO VIENE CON DECIMALES LO EXPLOTO Y FORMATEO 
        if(strpos((string)$this->amount, ".") == true){
            $number_array = explode(".", (string)$this->amount);
            $decimal = strlen($number_array[1]) <= 1 ? $number_array[1]."0" : $number_array[1];
            $this->amount = $number_array[0].$decimal;
        }else{
            $this->amount = str_pad($this->amount, strlen($this->amount)+2, "0", STR_PAD_RIGHT);#SI EL MONTO VIENE SIN DECIMALES LE AGREGO 2 CEROS AL FINAL
        }
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getExternalReference(): ?string
    {
        return $this->external_reference;
    }

    public function setExternalReference(string $external_reference): self
    {
        $this->external_reference = $external_reference;

        return $this;
    }

    public function getTerminal(): ?int
    {
        return $this->terminal;
    }

    public function setTerminal(int $terminal): self
    {
        $this->terminal = $terminal;

        return $this;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->payment_method->getMethodName();
    }

    public function setPaymentMethod(?PaymentMethod $payment_method): self
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getPaymentStatus(): ?PaymentStatus
    {
        return $this->payment_status;
    }

    public function setPaymentStatus(?PaymentStatus $payment_status): self
    {
        $this->payment_status = $payment_status;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPayment(): ?string
    {
        return $this->payment = $this->payment_method->getMethodName();
    }
    public function getStatus(): ?string
    {
        return $this->status = $this->payment_status->getStatus();
    }
 


}
