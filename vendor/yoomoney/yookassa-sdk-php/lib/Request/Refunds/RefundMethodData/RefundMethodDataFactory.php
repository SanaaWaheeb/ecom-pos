<?php

/*
 * The MIT License
 *
 * Copyright (c) 2025 "YooMoney", NBСO LLC
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace YooKassa\Request\Refunds\RefundMethodData;

use InvalidArgumentException;
use YooKassa\Model\Refund\RefundMethodType;

/**
 * Класс, представляющий модель RefundMethodDataFactory.
 *
 * Фабрика создания объекта методов возврата из массива.
 *
 * @category Class
 * @package  YooKassa\Model
 * @author   cms@yoomoney.ru
 * @link     https://yookassa.ru/developers/api
 */
class RefundMethodDataFactory
{
    private array $typeClassMap = [
        RefundMethodType::ELECTRONIC_CERTIFICATE => 'RefundMethodDataElectronicCertificate',
    ];

    /**
     * Фабричный метод создания объекта платежных данных по типу.
     *
     * @param string|null $type Тип платежного метода
     *
     * @return AbstractRefundMethodData
     */
    public function factory(?string $type): AbstractRefundMethodData
    {
        if (!is_string($type)) {
            throw new InvalidArgumentException('Invalid refund method type value in refund method factory');
        }
        if (!array_key_exists($type, $this->typeClassMap)) {
            throw new InvalidArgumentException('Invalid refund method data type "' . $type . '"');
        }
        $className = __NAMESPACE__ . '\\' . $this->typeClassMap[$type];

        return new $className();
    }

    /**
     * Фабричный метод создания объекта платежных данных из массива.
     *
     * @param array $data Массив платежных данных
     * @param null|string $type Тип платежного метода
     */
    public function factoryFromArray(array $data, ?string $type = null): AbstractRefundMethodData
    {
        if (null === $type) {
            if (array_key_exists('type', $data)) {
                $type = $data['type'];
                unset($data['type']);
            } else {
                throw new InvalidArgumentException(
                    'Parameter type not specified in RefundMethodDataFactory.factoryFromArray()'
                );
            }
        }

        $paymentData = $this->factory($type);
        $paymentData->fromArray($data);

        return $paymentData;
    }
}
