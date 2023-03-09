<?php 
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateNaissance extends Constraint
{
    public $message = 'La date de naissance doit être une date valide.';
    public $groups = [];
    public $payload = [];

    public function validatedBy()
    {
        return DateNaissanceValidator::class;
    }
}
