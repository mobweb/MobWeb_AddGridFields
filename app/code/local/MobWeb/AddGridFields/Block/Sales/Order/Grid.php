<?php
class MobWeb_AddGridFields_Block_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{
    public function setCollection($collection)
    {
        // Extend the collection to include the relevant fields from
        // the order address table
        $collection->getSelect()->joinLeft(
            array('billing' => $collection->getTable('sales/order_address')),
            'main_table.entity_id = billing.parent_id AND billing.address_type = "billing"',
            array(
                'billing.street AS billing_street',
                'billing.postcode AS billing_postcode',
                'billing.country_id AS billing_country_id',
            )
        );

        $collection->getSelect()->joinLeft(
            array('shipping' => $collection->getTable('sales/order_address')),
            'main_table.entity_id = shipping.parent_id AND shipping.address_type = "shipping"',
            array(
                'shipping.street AS shipping_street',
                'shipping.postcode AS shipping_postcode',
                'shipping.country_id AS shipping_country_id',
            )
        );

        $collection->getSelect()->group('main_table.entity_id');

        return parent::setCollection($collection);
    }

    protected function _prepareColumns()
    {
        // Add the columns to the order grid
        $this->addColumnAfter('billing_country_id',
            array(
                'header'        => Mage::helper('sales')->__('Bill to Country'),
                'index'         => 'billing_country_id',
                'filter_index'  => 'billing.country_id'
            ),
            'billing_name'
        );

        $this->addColumnAfter('billing_postcode',
            array(
                'header'        => Mage::helper('sales')->__('Bill to ZIP'),
                'index'         => 'billing_postcode',
                'filter_index'  => 'billing.postcode'
            ),
            'billing_name'
        );

        $this->addColumnAfter('billing_street',
            array(
                'header'        => Mage::helper('sales')->__('Bill to street'),
                'index'         => 'billing_street',
                'filter_index'  => 'billing.street'
            ),
            'billing_name'
        );

        $this->addColumnAfter('customer_id',
            array(
                'header'        => Mage::helper('sales')->__('Customer ID'),
                'index'         => 'customer_id',
                'filter_index'  => 'main_table.customer_id'
            ),
            'created_at'
        );

        $this->addColumnAfter('shipping_country_id',
            array(
                'header'        => Mage::helper('sales')->__('Ship to Country'),
                'index'         => 'shipping_country_id',
                'filter_index'  => 'shipping.country_id'
            ),
            'shipping_name'
        );

        $this->addColumnAfter('shipping_postcode',
            array(
                'header'        => Mage::helper('sales')->__('Ship to ZIP'),
                'index'         => 'shipping_postcode',
                'filter_index'  => 'shipping.postcode'
            ),
            'shipping_name'
        );

        $this->addColumnAfter('shipping_street',
            array(
                'header'        => Mage::helper('sales')->__('Ship to street'),
                'index'         => 'shipping_street',
                'filter_index'  => 'shipping.street'
            ),
            'shipping_name'
        );

        return parent::_prepareColumns();
    }
}