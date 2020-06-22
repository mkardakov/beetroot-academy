<?php
declare(strict_types=1);


namespace App\View;

/**
 * Class Template
 * @package App\View
 */
class Template
{
    const DEFAULT_TEMPLATE = 'main';
    /**
     * @var array
     */
    private $output;

    /**
     * @var string
     */
    private $template;

    /**
     * Template constructor.
     * @param array  $output
     * @param string $template
     */
    public function __construct(array $output, $template = Template::DEFAULT_TEMPLATE)
    {
        $this->output = $output;
        $this->template = $template;
    }

    /**
     * @return string
     */
    private function getTemplate() : string
    {
        $output = $this->output;
        ob_start();
        require "templates/{$this->template}.phtml";
        return ob_get_clean();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTemplate();
    }
}