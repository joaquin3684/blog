<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 28/08/17
 * Time: 21:08
 */

namespace App\Exceptions;


use App\Traits\Conversion;

abstract class MiExceptionClass extends \Exception
{
    use Conversion;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $detail;

    /**
     * @param @string $message
     * @return void
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }

    public function getStatus()
    {
        return (int)$this->status;
    }

    public function toArray()
    {
        return [
            'id'     => $this->id,
            'status' => $this->status,
            'title'  => $this->title,
            'detail' => $this->detail
        ];
    }

    protected function build(array $args)
    {
        $this->id = array_shift($args);

        $error = config(sprintf('errors.%s', $this->id));

        $this->title = $error['title'];
        $this->detail = vsprintf($error['detail'], $args);

        return $this->detail;
    }


}