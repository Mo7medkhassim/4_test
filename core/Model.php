<?php

namespace app\Core;

use Attribute;
use Dibi;

abstract class Model
{

    public ?DbModel $user;
    public const RULES_REQUIRED = "required";
    public const RULES_EMAIL    = "email";
    public const RULES_MIN      = "min";
    public const RULES_MAX      = "max";
    public const RULES_MATCH    = "match";
    public const RULES_UNIQUE   = "unique";

    public function loudData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;
    public array $errors = [];

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULES_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULES_REQUIRED);
                }
                if ($ruleName === self::RULES_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULES_EMAIL);
                }
                if ($ruleName === self::RULES_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULES_MIN, $rule);
                }
                if ($ruleName === self::RULES_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorForRule($attribute, self::RULES_MATCH, $rule);
                }
                if ($ruleName === self::RULES_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;

                    $tableName = $className::tableName();
                    $attributeName = $className::attribute();
                    $attributeUnique = $attributeName['email'];
                    // echo '<br>';
                    $db = Application::$app->db::$database;
                    $stat =  $db->query("SELECT * FROM $tableName WHERE $uniqueAttribute = ?", "$attributeUnique");
                    $r = $stat->fetchAll();

                    if (!empty($r)) {
                        $this->addErrorForRule($attribute, self::RULES_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute,  string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::RULES_REQUIRED => 'This field is required',
            self::RULES_EMAIL => 'This field must be valid email address',
            self::RULES_MIN => 'Min length of this filed must be {min}',
            self::RULES_MAX => 'Max length of this field must be {max}',
            self::RULES_MATCH => 'This field must be the same as {match}',
            self::RULES_UNIQUE => 'Record with this {field} is already exists'
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
