<?php

namespace Drupal\media_entity_icon\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Media entity icon settings form.
 *
 * @package Drupal\media_entity_icon\Form
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'media_entity_icon_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'media_entity_icon.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('media_entity_icon.settings');

    $form['thumbnail_width'] = array(
      '#type' => 'number',
      '#min' => 1,
      '#step' => 1,
      '#title' => $this->t('Thumbnail width'),
      '#description' => $this->t('The width at which the png thumbnail will be generated.'),
      '#default_value' => $config->get('thumbnail_width'),
      '#required' => TRUE,
    );

    $form['svg2png_path'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('SVG2PNG path'),
      '#description' => $this->t('SVG2PNG binary location, if it is installed globally "svg2png" may be sufficient.'),
      '#default_value' => $config->get('svg2png_path'),
      '#required' => TRUE,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $svg2png_path = trim($form_state->getValue('svg2png_path'));
    $pattern = '#^([/a-z\d\-\_]+/)?svg2png$#i';

    if (!preg_match($pattern, $svg2png_path)) {
      $form_state->setErrorByName('svg2png_path', $this->t('SVG2PNG path seems invalid, expecting path like "svg2png" or "/usr/local/bin/svg2png".'));
    }
    else {
      $cmd = $svg2png_path . ' --help';
      try {
        exec($cmd, $output);
        if (empty($output[2]) || strpos($output[2], 'svg2png') !== 0) {
          $form_state->setErrorByName('svg2png_path', $this->t('SVG2PNG command do not match expectations.'));
        }
      }
      catch (\Exception $e) {
        $form_state->setErrorByName('svg2png_path', $this->t('An error occured while testing SVG2PNG: @error.', ['@error' => $e->getMessage()]));
      }
    }

    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::configFactory()->getEditable('media_entity_icon.settings')
      ->set('thumbnail_width', $form_state->getValue('thumbnail_width'))
      ->set('svg2png_path', trim($form_state->getValue('svg2png_path')))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
