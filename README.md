# Psmb.Ajaxify

This package allows you to mark any part of page for asynchronous loading via AJAX with just one line of Fusion code.
Why? It helps you to speed up initial page load by delaying the load of some less relevant parts of the page, e.g. comments.

![demo](https://cloud.githubusercontent.com/assets/837032/25178402/5b011f40-250e-11e7-9e6c-462b8e912893.gif)


## Usage

1. Install the package

```
composer require psmb/ajaxify
```

2. Add `@process.myUniqueKey = Psmb.Ajaxify:Ajaxify` on any Fusion path. **The `myUniqueKey` key of the processor MUST be globally unique.**


3. Add this anywhere in your Fusion code to include the sample AJAX loading script:

```
prototype(Neos.Neos:Page).head.ajaxLoader = Psmb.Ajaxify:CssTag
prototype(Neos.Neos:Page).body.javascripts.ajax = Psmb.Ajaxify:JsTag
```

Or include these assets via your build tool. Or just write your own loader.

4. Done. Now part of your pages will be lazily loaded via an AJAX request.

**Note:** the Fusion component should not depend on any context variables, other than the standard ones.
If you want to reuse some EEL expression in your code base, don't put it into context, rather wrap it into `Neos.Fusion:Value` object and use it everywhere you like.

5. You may override the `Psmb.Ajaxify:Loader` object in order to customize the loader.
