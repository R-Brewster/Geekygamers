<?php

namespace UpsFreeVendor\Ups\Entity;

class Shipment
{
    /**
     * @var PaymentInformation
     */
    private $paymentInformation;
    /**
     * @var RateInformation
     */
    private $rateInformation;
    /**
     * @var string
     */
    private $description;
    /**
     * @var Shipper
     */
    private $shipper;
    /**
     * @var ShipTo;
     */
    private $shipTo;
    /**
     * @var SoldTo
     */
    private $soldTo;
    /**
     * @var ShipFrom
     */
    private $shipFrom;
    /**
     * @var AlternateDeliveryAddress
     */
    private $alternateDeliveryAddress;
    /**
     * @var ShipmentIndicationType
     */
    private $shipmentIndicationType;
    /**
     * @var Service
     */
    private $service;
    /**
     * @var ReturnService
     */
    private $returnService;
    /**
     * @var bool
     */
    private $documentsOnly;
    /**
     * @var Package[]
     */
    private $packages = [];
    /**
     * @var ReferenceNumber
     */
    private $referenceNumber;
    /**
     * @var ReferenceNumber
     */
    private $referenceNumber2;
    /**
     * @var ShipmentServiceOptions
     */
    private $shipmentServiceOptions;
    /**
     * @var bool
     */
    private $goodsNotInFreeCirculationIndicator;
    /**
     * @var string
     */
    private $movementReferenceNumber;
    /**
     * @var InvoiceLineTotal
     */
    private $invoiceLineTotal;
    /**
     * @var string
     */
    private $numOfPiecesInShipment;
    /**
     * @var DeliveryTimeInformation
     */
    private $deliveryTimeInformation;
    public function __construct()
    {
        $this->setShipper(new \UpsFreeVendor\Ups\Entity\Shipper());
        $this->setShipTo(new \UpsFreeVendor\Ups\Entity\ShipTo());
        $this->setShipmentServiceOptions(new \UpsFreeVendor\Ups\Entity\ShipmentServiceOptions());
        $this->setService(new \UpsFreeVendor\Ups\Entity\Service());
        $this->rateInformation = null;
    }
    /**
     * @return ShipmentIndicationType
     */
    public function getShipmentIndicationType()
    {
        return $this->shipmentIndicationType;
    }
    /**
     * @param ShipmentIndicationType $shipmentIndicationType
     */
    public function setShipmentIndicationType(\UpsFreeVendor\Ups\Entity\ShipmentIndicationType $shipmentIndicationType)
    {
        $this->shipmentIndicationType = $shipmentIndicationType;
    }
    /**
     * @return AlternateDeliveryAddress
     */
    public function getAlternateDeliveryAddress()
    {
        return $this->alternateDeliveryAddress;
    }
    /**
     * @param AlternateDeliveryAddress $alternateDeliveryAddress
     */
    public function setAlternateDeliveryAddress(\UpsFreeVendor\Ups\Entity\AlternateDeliveryAddress $alternateDeliveryAddress)
    {
        $this->alternateDeliveryAddress = $alternateDeliveryAddress;
    }
    /**
     * @param Package $package
     *
     * @return Shipment
     */
    public function addPackage(\UpsFreeVendor\Ups\Entity\Package $package)
    {
        $packages = $this->getPackages();
        $packages[] = $package;
        $this->setPackages($packages);
        return $this;
    }
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @param string $description
     *
     * @return Shipment
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    /**
     * @param ReferenceNumber $referenceNumber
     *
     * @return Shipment
     */
    public function setReferenceNumber(\UpsFreeVendor\Ups\Entity\ReferenceNumber $referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;
        return $this;
    }
    /**
     * @param ReferenceNumber $referenceNumber
     *
     * @return Shipment
     */
    public function setReferenceNumber2(\UpsFreeVendor\Ups\Entity\ReferenceNumber $referenceNumber)
    {
        $this->referenceNumber2 = $referenceNumber;
        return $this;
    }
    /**
     * @return ReferenceNumber
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }
    /**
     * @return ReferenceNumber
     */
    public function getReferenceNumber2()
    {
        return $this->referenceNumber2;
    }
    /**
     * @return bool
     */
    public function getDocumentsOnly()
    {
        return $this->documentsOnly;
    }
    /**
     * @param bool $documentsOnly
     *
     * @return Shipment
     */
    public function setDocumentsOnly($documentsOnly)
    {
        $this->documentsOnly = $documentsOnly;
        return $this;
    }
    /**
     * @return Package[]
     */
    public function getPackages()
    {
        return $this->packages;
    }
    /**
     * @param Package[] $packages
     *
     * @return Shipment
     */
    public function setPackages(array $packages)
    {
        $this->packages = $packages;
        return $this;
    }
    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }
    /**
     * @param Service $service
     *
     * @return Shipment
     */
    public function setService(\UpsFreeVendor\Ups\Entity\Service $service)
    {
        $this->service = $service;
        return $this;
    }
    /**
     * @return ReturnService
     */
    public function getReturnService()
    {
        return $this->returnService;
    }
    /**
     * @param ReturnService $returnService
     *
     * @return Shipment
     */
    public function setReturnService(\UpsFreeVendor\Ups\Entity\ReturnService $returnService)
    {
        $this->returnService = $returnService;
        return $this;
    }
    /**
     * @return ShipFrom
     */
    public function getShipFrom()
    {
        return $this->shipFrom;
    }
    /**
     * @param ShipFrom $shipFrom
     *
     * @return Shipment
     */
    public function setShipFrom(\UpsFreeVendor\Ups\Entity\ShipFrom $shipFrom)
    {
        $this->shipFrom = $shipFrom;
        return $this;
    }
    /**
     * @return ShipTo
     */
    public function getShipTo()
    {
        return $this->shipTo;
    }
    /**
     * @param ShipTo $shipTo
     *
     * @return Shipment
     */
    public function setShipTo(\UpsFreeVendor\Ups\Entity\ShipTo $shipTo)
    {
        $this->shipTo = $shipTo;
        return $this;
    }
    /**
     * @return SoldTo
     */
    public function getSoldTo()
    {
        return $this->soldTo;
    }
    /**
     * @param SoldTo $soldTo
     *
     * @return Shipment
     */
    public function setSoldTo(\UpsFreeVendor\Ups\Entity\SoldTo $soldTo)
    {
        $this->soldTo = $soldTo;
        return $this;
    }
    /**
     * @return ShipmentServiceOptions
     */
    public function getShipmentServiceOptions()
    {
        return $this->shipmentServiceOptions;
    }
    /**
     * @param ShipmentServiceOptions $shipmentServiceOptions
     *
     * @return Shipment
     */
    public function setShipmentServiceOptions(\UpsFreeVendor\Ups\Entity\ShipmentServiceOptions $shipmentServiceOptions)
    {
        $this->shipmentServiceOptions = $shipmentServiceOptions;
        return $this;
    }
    /**
     * @return Shipper
     */
    public function getShipper()
    {
        return $this->shipper;
    }
    /**
     * @param Shipper $shipper
     *
     * @return Shipment
     */
    public function setShipper(\UpsFreeVendor\Ups\Entity\Shipper $shipper)
    {
        $this->shipper = $shipper;
        return $this;
    }
    /**
     * @return PaymentInformation
     */
    public function getPaymentInformation()
    {
        return $this->paymentInformation;
    }
    /**
     * @param PaymentInformation $paymentInformation
     *
     * @return Shipment
     */
    public function setPaymentInformation(\UpsFreeVendor\Ups\Entity\PaymentInformation $paymentInformation)
    {
        $this->paymentInformation = $paymentInformation;
        return $this;
    }
    /**
     * If called, returned prices will include negotiated rates (discounts will be applied).
     */
    public function showNegotiatedRates()
    {
        $this->rateInformation = new \UpsFreeVendor\Ups\Entity\RateInformation();
        $this->rateInformation->setNegotiatedRatesIndicator(\true);
    }
    /**
     * @return null|RateInformation
     */
    public function getRateInformation()
    {
        return $this->rateInformation;
    }
    /**
     * @param RateInformation $rateInformation
     *
     * @return Shipment
     */
    public function setRateInformation(\UpsFreeVendor\Ups\Entity\RateInformation $rateInformation)
    {
        $this->rateInformation = $rateInformation;
        return $this;
    }
    /**
     * @return boolean
     */
    public function getGoodsNotInFreeCirculationIndicator()
    {
        return $this->goodsNotInFreeCirculationIndicator;
    }
    /**
     * @param boolean $goodsNotInFreeCirculationIndicator
     * @return Shipment
     */
    public function setGoodsNotInFreeCirculationIndicator($goodsNotInFreeCirculationIndicator)
    {
        $this->goodsNotInFreeCirculationIndicator = $goodsNotInFreeCirculationIndicator;
        return $this;
    }
    /**
     * @return string
     */
    public function getMovementReferenceNumber()
    {
        return $this->movementReferenceNumber;
    }
    /**
     * @param string $movementReferenceNumber
     * @return Shipment
     */
    public function setMovementReferenceNumber($movementReferenceNumber)
    {
        $this->movementReferenceNumber = $movementReferenceNumber;
        return $this;
    }
    /**
     * @return InvoiceLineTotal
     */
    public function getInvoiceLineTotal()
    {
        return $this->invoiceLineTotal;
    }
    /**
     * @param InvoiceLineTotal $invoiceLineTotal
     * @return Shipment
     */
    public function setInvoiceLineTotal(\UpsFreeVendor\Ups\Entity\InvoiceLineTotal $invoiceLineTotal)
    {
        $this->invoiceLineTotal = $invoiceLineTotal;
        return $this;
    }
    /**
     * @return string
     */
    public function getNumOfPiecesInShipment()
    {
        return $this->numOfPiecesInShipment;
    }
    /**
     * @param string $numOfPiecesInShipment
     * @return Shipment
     */
    public function setNumOfPiecesInShipment($numOfPiecesInShipment)
    {
        $this->numOfPiecesInShipment = $numOfPiecesInShipment;
        return $this;
    }
    /**
     * @return DeliveryTimeInformation
     */
    public function getDeliveryTimeInformation()
    {
        return $this->deliveryTimeInformation;
    }
    /**
     * @param DeliveryTimeInformation $deliveryTimeInformation
     */
    public function setDeliveryTimeInformation(\UpsFreeVendor\Ups\Entity\DeliveryTimeInformation $deliveryTimeInformation)
    {
        $this->deliveryTimeInformation = $deliveryTimeInformation;
    }
}
