<?php

namespace App\Traits;

use Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;

trait ModelValidate
{
    protected $skipValidaton;
    
    public static function bootModelValidate()
    {
        static::saving(function (Model $model) {
            return $model->validate();
        });
    }
    
    /**
     * Validate model before save
     *
     * @param array $data
     * @param array $rules
     * @return void
     * 
     * @throws ValidationException
     */
    public function validate(array $data = [], array $rules = [])
    {
        if (isset($this->validationRules) && !$this->skipValidaton) {
            $data = $data ? $data : $this->attributes;
            $rules = $rules ? $rules : $this->getRules();
            $validator = Validator::make($data, $rules, $this->getErrorMessages());
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        }
    }
    
    /**
     * Get validation rules
     * 
     * @return array
     */
    public function getRules()
    {
        return $this->validationRules;
    }
    
    /**
     * Set validation rules
     * 
     * @param array $rules
     * @return $this
     */
    public function setRules($rules)
    {
        if (!property_exists($this, 'validationRules')) {
            throw new \Exception('validationRules property should be defined');
        }
        $this->validationRules = $rules;
        
        return $this;
    }

    /**
     * Set validation messages
     *
     * @param array $messages
     * @return $this
     */
    public function setMessages(array $messages)
    {
        if (!property_exists($this, 'validationMessages')) {
            throw new \Exception('validationRules property should be defined');
        }
        $this->validationMessages = $messages;

        return $this;
    }
    
    /**
     * Set validation message for field
     * 
     * @param string $key
     * @param string $message
     * @return $this
     * 
     * @throws \Exception
     */
    public function setMessage($key, $message)
    {
        if (!property_exists($this, 'validationMessages')) {
            throw new \Exception('validationRules property should be defined');
        }
        $this->validationMessages[$key] = $message;
        
        return $this;
    }
    
    /**
     * Set validation rule
     * 
     * @param string $key
     * @param string $rule
     * @return $this
     */
    public function setRule($key, $rule)
    {
        if (!property_exists($this, 'validationRules')) {
            throw new \Exception('validationRules property should be defined');
        }
        $this->validationRules[$key] = $rule;
        
        return $this;
    }
    
    /**
     * Set skip validation
     * 
     * @param bool $skip
     * @return $this
     */
    public function skipValidation($skip = true)
    {
        $this->skipValidaton = $skip;
        
        return $this;
    }
    
    /**
     * Get error messages list
     * 
     * @return array
     */
    public function getErrorMessages()
    {
        return property_exists($this, 'validationMessages') ? $this->validationMessages : [];
    }
    
    /**
     * Get validation rule by key
     *
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function getRule($key)
    {
        if (!property_exists($this, 'validationRules')) {
            throw new \Exception('validationRules property should be defined');
        }
        return array_get($this->validationRules, $key);
    }
}