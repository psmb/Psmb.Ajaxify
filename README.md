# Psmb.Ajaxify:Ajaxify

## Usage

```
composer require psmb/ajaxify
```

Add `@process.myUniqueKey = Psmb.Ajaxify:Ajaxify` on any Fusion path. **The `myUniqueKey` key of the processor MUST be globally unique.**

Done.

**Note:** the Fusion component should not depend on any context variables, other than the standard ones.
If you want to reuse some EEL expression in your code base, don't put it into context, rather wrap it into `Neos.Fusion:Value` object and use it everywhere you like.

TODO: add some sample JS loader. Will do soonish.
