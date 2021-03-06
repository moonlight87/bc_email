<?php
class Bc_Email_Block_Adminhtml_Rule_Edit_Tab_Sendcopy extends Mage_Adminhtml_Block_Widget_Form
{
    public function _prepareForm(){
        $data = Mage::registry('email_data');
        if (is_object($data)) {
            $data = $data->getData();
        }

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('email_sendcopy', array('legend' => $this->__('Send copy')));

        # email_copy_to field
        $fieldset->addField(
            'email_copy_to', 'text',
            array(
                'label'              => $this->__('Send copy to email'),
                'name'               => 'email_copy_to',
                'note'               => $this->__('Separate e-mails by spaces, commas, or semicolons'),
                'after_element_html' =>
                    '<span class="note"><small>'
                    . $this->__('These addresses will be added to the BCC: fields of the emails generated by the rule')
                    . '</small></span>',
            )
        );

        $fieldset->addField(
            'email_send_to_customer', 'select',
            array(
                'label'    => 'Send email to customer',
                'name'     => 'email_send_to_customer',
                'values'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
                'onchange' => 'checkSendToCustomer()',
                'note'     => $this->__(
                    'If "No" is selected, email will be sent to recipients specified in the '
                    . '"Send copy to email" field only'
                )
            )
        );


        if (!isset($data['email_send_to_customer'])) {
            $data['email_send_to_customer'] = 1;
        }

        $form->setValues($data);
        $this->setForm($form);
        return parent::_prepareForm();

    }
}