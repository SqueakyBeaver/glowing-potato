<?php
// Class to make it easier to deal with inputs and outputs
class InOutBubble {
    // Either "server-sent" or "user-sent"
    private $type;
    private $content;

    public function __construct($type, $content) {
        if ($type !== "server-sent" && $type !== "user-sent") {
            $this->type = "";
        } else {
            $this->type = $type;
        }
        $this->content = $content;
    }

    public function getType() {
        return $this->type;
    }

    public function getContent() {
        return htmlspecialchars($this->content);
    }
}