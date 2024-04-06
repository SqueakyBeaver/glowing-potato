<?php
// Class to make it easier to deal with inputs and outputs
class InOutBubble {
    // Either "server-sent" or "user-sent"
    private $sender;
    private $content;

    public function __construct($sender, $content) {
        if ($sender !== "server-sent" && $sender !== "user-sent") {
            $this->sender = "";
        } else {
            $this->sender = $sender;
        }
        $this->content = $content;
    }

    public function getSender() {
        return $this->sender;
    }

    public function getContent() {
        return $this->content;
    }
}