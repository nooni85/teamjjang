<?php
class Layout
{
    private string $layoutHtml;

    private array $pluginsHtml = [];
    private string $title;

    public function __construct()
    {
        ob_start([&$this, 'before_flush_page']);
    }

    private function str_replace_first($search, $replace, $subject)
    {
        $search = '/'.preg_quote($search, '/').'/';
        return preg_replace($search, $replace, $subject, 1);
    }

    private function before_flush_page($buffer): string
    {
        //apply content
        $cnt = 1;
        $html = $this->str_replace_first("[[[__CONTENT__]]]", $buffer, $this->layoutHtml);
        $html = $this->str_replace_first("[[[__TITLE__]]]", $this->title, $html);
        return $html;
    }

    public function setTitle(string $title): Layout
    {
        $this->title = $title;
        return $this;
    }

    public function apply(string $name): void
    {
        ob_start();
        require_once __DIR__."/layout/".$name.".php";
        $this->layoutHtml = ob_get_contents();
        ob_end_clean();

        // apply plugin
        foreach ($this->pluginsHtml as $key => $value) {
            $script = "<script type=\"text/javascript\" src=\"".$_SERVER['CONTEXT_PREFIX']."/js/plugin/".$key.".js\"></script>";
            $css = "<link rel=\"stylesheet\" href=\"".$_SERVER['CONTEXT_PREFIX']."/css/plugin/".$key.".css\">";
            $this->layoutHtml = $this->str_replace_first("</head>", $css."</head>", $this->layoutHtml);
            $this->layoutHtml = $this->str_replace_first("</head>", $script."</head>", $this->layoutHtml);
            $this->layoutHtml = $this->str_replace_first("<body>", $value."<body>", $this->layoutHtml);
        }
    }

    public function plugin(string $name): Layout
    {
        ob_start();
        require_once __DIR__."/plugin/".$name.".php";
        $this->pluginsHtml[$name] = ob_get_contents();
        ob_end_clean();

        return $this;
    }
}