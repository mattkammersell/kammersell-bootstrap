{
    "name": "vendor/module-{{LOWERCASE_NAMESPACE}}",
    "description": "{{VENDOR}}_{{NAMESPACE}}",
    "type": "magento2-module",
    "version": "1.0.0",
    "autoload": {
        "files": [
            "registration.php"
        ],
        "psr-4": {
            "{{VENDOR}}\\{{NAMESPACE}}\\": ""
        }
    }
}
