<?php

namespace App\HTML;

class Form {

  // Returns an HTML input element
  public function createInput(string $type, string $key, string $id, string $label, string $spacing): string
  {
    return <<<HTML
      <div class="{$this->getSpacingClass($spacing)}">
        <input class="form-control" type="{$type}" name="{$key}" id="{$id}-{$key}" placeholder="{$label}" required>
        <label for="{$id}-{$key}">$label</label>
      </div>
HTML;
  }

  // Returns an HTML select element
  public function createSelect(string $key, string $id, string $label, string $spacing, array $options): string
  {
    $result = <<<HTML
      <div class="{$this->getSpacingClass($spacing)}">
        <select name="{$key}" id="{$id}-{$key}" class="form-select">
HTML;
    foreach ($options as $option) {
      $result .= $this->createOption($option);
    }
    $result .= <<<HTML
        </select>
        <label for="{$id}-{$key}">$label</label>
      </div>
HTML;
    return $result;
  }

  // Returns an HTML option element
  private function createOption(string $value, ?string $selected = null): string
  {
    return <<<HTML
      <option value="{$value}" $selected>$value</option>
HTML;
  }

  // Returns the contents of the class attribute of a div
  private function getSpacingClass(string $spacing): string
  {
    $classDiv = 'form-floating';
    if (!empty($spacing)) {
      $classDiv .= ' ' . $spacing;
    }
    return $classDiv;
  }

  // Returns an HTML small element with an error message
  public function displayErrorMessage(string $field, string $key, string $id): string
  {
    switch ($field) {
      case 'int13':
        $result = "Numéro de 13 chiffres en commençant par 0033 (Donnée requise)";
        break;
      case 'str30':
        $result = "Entre 3 et 30 lettres (Donnée requise)";
        break;
      case 'strEmail':
        $result = "Entre 6 et 100 caractères | @ et . inclus (Donnée requise)";
        break;
      case 'strPassword':
        $result[] = "Entre 8 et 60 caractères (Donnée requise)";
        $result[] .= "1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial inclus";
        break;
      case 'login':
        $result = "Identifiant ou mot de passe incorrect";
        break;
    }
    
    $error = (is_array($result)) ? implode('<br>', $result) : $result;
    
    return <<<HTML
      <small class="invalid-feedback d-none" id="{$id}-{$key}-error">
        $error
      </small>
HTML;
  }  
}