<?php

abstract class Controller
{
    /**
     * Render a view file and pass data to it.
     */
    protected function view(string $viewPath, array $data = []): void
    {
        extract($data);
        $file = __DIR__ . '/../app/Views/' . $viewPath . '.php';

        if (file_exists($file)) {
            require $file;
        } else {
            http_response_code(404);
            die("View file [{$viewPath}] not found.");
        }
    }

    /**
     * Redirect to another URL.
     */
    protected function redirect(string $url): void
    {
        header("Location: " . $url);
        exit;
    }
}
