<?php

namespace App\Filter;

use App\DTO\PromotionsEnquiryInterface;
interface PromotionsFilterInterface
{
    public function apply(PromotionsEnquiryInterface $enquiry): PromotionsEnquiryInterface;
}