<?php  namespace Coach\Core\Commands;

use Dugan\Captain\Contracts\CommandResponse;

class BaseCommandResponse implements CommandResponse
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var array
     */
    private $flash_data;

    /**
     * @var MessageBag|array
     */
    private $errors;

    /**
     * @var bool
     */
    private $success;

    /**
     * Returns a JSON encoding of the response
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode([
            'errors'     => $this->errors,
            'viewData'       => $this->data,
            'flash_data' => $this->flash_data,
            'success'    => $this->success
        ], $options);
    }

    /**
     * Sets success and flash viewData given a message
     * $message should be either a string or
     * ['flash_success' => 'Your success message']
     *
     * @param null $message
     * @return void
     */
    public function success($message = null)
    {
        $this->setSuccess(true);
        if (is_array($message)) {
            $this->setFlashData($message);
        } else {
            $this->setFlashData(['flash_success' => $message]);
        }
    }

    /**
     * Sets failure and flash viewData given a message
     * This function will automatically check the errors var to see
     * if anything has been stored prior to using the passed in message
     * $message should be either a string or
     * ['flash_error' => 'Your success message']
     *
     * @param null $message
     * @return void
     */
    public function fail($message = null)
    {
        $this->setSuccess(false);

        if ($this->hasErrors()) {
            if (is_array($this->getErrors())) {
                $this->setFlashData($this->getErrors());
            } else {
                $this->setFlashData(['flash_error' => $this->getErrors()]);
            }
        } else {
            if (is_array($message)) {
                $this->setFlashData($message);
            } else {
                $this->setFlashData(['flash_error' => $message]);
            }
        }
    }

    /**
     * Was the command successful?
     *
     * @return bool
     */
    public function successful()
    {
        return $this->success;
    }

    /**
     * Was the command a failure?
     *
     * @return bool
     */
    public function failed()
    {
        return ! $this->success;
    }

    /**
     * Sets the
     *
     * @param $status
     * @return void
     */
    public function setSuccess($status)
    {
        if(! is_bool($status)) {
            throw new \InvalidArgumentException('Argument must be true or false, '.$status.' given');
        }

        $this->success = $status;
    }

    /**
     * Returns an array of flash viewData which may contain one or more of: flash_success, flash_error, flash_warning, flash_info
     *
     * @return mixed
     */
    public function getFlashData()
    {
        return $this->flash_data;
    }

    /**
     * Simple transporter for flash viewData. Should be passed an array containing one or more of: flash_success, flash_error, flash_warning, flash_info
     *
     * @param $flash_data
     * @return void
     */
    public function setFlashData($flash_data)
    {
        foreach ($flash_data as $k => $v) {
            $this->flash_data[$k] = $v;
        }
    }

    /**
     * Does the object have flash viewData?
     *
     * @return bool
     */
    public function hasFlashData()
    {
        return ! empty($this->flash_data);
    }

    /**
     * Simple getter
     *
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Simple setter
     *
     * @param $errors
     * @return void
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public function hasErrors()
    {
        return ! empty($this->errors);
    }

    /**
     * Simple getter
     *
     * @param null $key
     * @return mixed
     */
    public function getData($key = null)
    {
        return $key && isset($this->data[$key]) ? $this->data[$key] : $this->data;
    }

    /**
     * Simple setter
     *
     * @param      $key
     * @param null $value
     * @return void
     */
    public function setData($key, $value = null)
    {
        if($value) {
            $this->data[$key] = $value;
        } else {
            $this->data = $key;
        }
    }
}
