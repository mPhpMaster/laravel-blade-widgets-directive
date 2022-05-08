# Laravel blade widgets directive module

---

### How to implement:
1. Register `WidgetServiceProvider` in `config/app.php`
2. Use `app\Widgets\ExampleWidget.php` as widget template 

---

### Use it in blade like this: 
```php
@widget('example', [/* any data to pass */])
``` 
