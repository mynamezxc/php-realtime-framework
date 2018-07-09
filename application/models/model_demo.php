<?php

    class model_demo extends ZXC_model {

        public function __construct() {
            parent::__construct();
        }

        public function demo_get_database() {
            $this->database->get(['arrow', 'aright', 'array']);
            return $this->database->build_query();
        }

    }