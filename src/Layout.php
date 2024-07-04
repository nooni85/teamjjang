<?php
class Layout
{
    private string $layoutHtml;

    private array $pluginsHtml = [];

    private string $title;

    private bool $csrf = false;

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
        $content = $buffer;

        if(error_get_last() != null) {
            return $buffer;
        }

        // apply csrf
        if($this->csrf === true) {
            $input = "<input type='hidden' name='csrf' value='".$_SESSION['csrf']."'>";
            $content = $this->str_replace_first("</form>", $input."</form>", $content);
        }

        //apply content
        $html = $this->str_replace_first("[[[__CONTENT__]]]", $content, $this->layoutHtml);
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

        // apply addon
        foreach ($this->pluginsHtml as $key => $value) {
            $script = "\t<script type=\"text/javascript\" src=\"".$_SERVER['CONTEXT_PREFIX']."/js/addon/".$key.".js\"></script>\r\n";
            $css = "\t<link rel=\"stylesheet\" href=\"".$_SERVER['CONTEXT_PREFIX']."/css/addon/".$key.".css\">\r\n";
            $this->layoutHtml = $this->str_replace_first("</head>", $css."</head>", $this->layoutHtml);
            $this->layoutHtml = $this->str_replace_first("</head>", $script."</head>", $this->layoutHtml);
            $this->layoutHtml = $this->str_replace_first("<body>", $value."<body>", $this->layoutHtml);
        }
    }

    public function csrf(): Layout
    {
        if(session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }

        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (empty($_SESSION['csrf'])) {
                $_SESSION['csrf'] = bin2hex(random_bytes(32));
            }
        } else if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_REQUEST['csrf'])) {
                if (!hash_equals($_SESSION['csrf'], $_REQUEST['csrf'])) {
                    throw new Exception('form validation failed');
                }
            } else {
                throw new Exception('csrf not found');
            }
        }

        $this->csrf = true;

        return $this;
    }
}

