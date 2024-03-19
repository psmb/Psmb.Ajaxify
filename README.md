# Psmb.Ajaxify

Enhance your NeosCMS experience with Psmb.Ajaxify, a powerful package that streamlines asynchronous loading of specific page components through AJAX, all with just one line of Fusion code. Why bother? It significantly accelerates the initial page load by deferring the loading of less critical parts, such as comments.

![See it in action](https://cloud.githubusercontent.com/assets/837032/25178402/5b011f40-250e-11e7-9e6c-462b8e912893.gif)


## TL;DR

### **Installation**:

```bash
composer require psmb/ajaxify
```

### Integration:

Add `@process.myUniqueKey = Psmb.Ajaxify:Ajaxify` to any Fusion path. Ensure that the `myUniqueKey` remains globally unique.

Incorporate the sample AJAX loading script into your Fusion code:

```fusion
prototype(Neos.Neos:Page).head.ajaxLoader = Psmb.Ajaxify:CssTag
prototype(Neos.Neos:Page).body.javascripts.ajax = Psmb.Ajaxify:JsTag
```

Alternatively, integrate these assets via your preferred build tool or craft your custom loader.

### Completion:

Done. Now part of your pages will be lazily loaded via an AJAX request.

**Note**: Ensure that your Fusion component doesn't rely on any context variables apart from the standard ones. If you need to reuse an EEL expression, refrain from embedding it into context. Instead, encapsulate it within a `Neos.Fusion:Value` object for universal usage.

### Customization:

Feel free to override the `Psmb.Ajaxify:Loader` object to tailor the loader according to your requirements.

## Compatibility and Maintenance

This package is currently being maintained for the following versions:

| Neos Version       | Version | Maintained |
|--------------------|---------|------------|
| Neos 7.3 and above | 1.x     | Yes        |
| Neos 3.3 - 7.2     | 0.4     | No         |

## Contribution

Feel free to tweak and optimize your NeosCMS setup with Psmb.Ajaxify. Streamline your page loads and provide a smoother user experience effortlessly.
