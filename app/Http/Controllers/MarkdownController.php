<?php

namespace App\Http\Controllers;
use Parsedown;

use Illuminate\Http\Request;

class MarkdownController extends Controller
{
    public function showNotes(string $markdownText){
        $htmlContent = Parsedown::instance()->text($markdownText);
    }
}
