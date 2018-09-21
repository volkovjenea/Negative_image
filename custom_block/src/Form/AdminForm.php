<?php
/**
 * @file
 * Contains Drupal\custom_block\Form\AdminForm.
 */
	namespace Drupal\custom_block\Form;

	use Drupal\Core\Form\ConfigFormBase;
	use Drupal\Core\Form\FormStateInterface;

	class AdminForm extends ConfigFormBase{
		/**
			* {@inheritdoc}
			*/
		protected function getEditableConfigNames() {
			return [
				'custom_block.adminsettings',
			];
		}
		/**
			* {@inheritdoc}
			*/
		public function getFormId() {
			return 'custom_block_form';
		}
		/**
		 * {@inheritdoc}
		 */

		public function buildForm(array $form, FormStateInterface $form_state) {
			$config = $this->config('custom_block.adminsettings');

			$form['title_field'] = [
				'#type' => 'textfield',
				'#title' => $this->t('Title'),
				'#description' => $this->t('Title of new something!'),
				'#default_value' => $config->get('title_field'),
			];
			$form['body_field'] = [
				'#type' => 'textfield',
				'#title' => $this->t('Body'),
				'#description' => $this->t('Body of new something!'),
				'#default_value' => $config->get('body_field'),
			];
      $form['imagearray'] = array(
        '#title' => t('image'),
        '#type' => 'managed_file',
        '#description' => t('The uploaded image will be displayed on this page using the image style chosen below.'),
        '#default_value' => $config->get('imagearray'),
        '#upload_location' => 'public://images/',
        '#required' => FALSE,
      );


			return parent::buildForm($form, $form_state);

		}

		public function submitForm(array &$form, FormStateInterface $form_state) {
			parent::submitForm($form, $form_state);

			$this->config('custom_block.adminsettings')
				->set('title_field', $form_state->getValue('title_field'))
				->set('body_field', $form_state->getValue('body_field'))
        ->set('imagearray',$form_state->getValue('imagearray'))
				->save();
		}

	}