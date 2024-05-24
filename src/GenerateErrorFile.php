<?php

namespace Azcend\Core;

class GenerateErrorFile
{
    public static function run(int $code) {
        return <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>$code</title>
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap');
            
                    * {
                        font-family: 'Noto Sans', sans-serif;
                    }
            
                    html {
                        background-color: #303030;
                        color: #e3e3e3;
                    }
                </style>
            </head>
            <body>
              <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                  <h1>$code</h1>
              </div>
            </body>
            </html>
            HTML;

    }
}