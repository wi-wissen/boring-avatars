# Boring Avatars

Boring avatars are tiny PHP Classes that generates custom, SVG-based avatars from any username and color palette like [boringdesigners/boring-avatars](https://github.com/boringdesigners/boring-avatars).

You can use the classes directly to get SVG as string:

```php
use BoringAvatars\AvatarBeam;

AvatarBeam::make([
    'name' => 'Jane Doe',
    'size' => '120', // in px
    'colors' => ['#ffad08',' #edd75a',' #73b06f',' #0c8f8f',' #405059'],
    'title' => true, //set name property as title tag in generated svg
    'square' => false,
]);
```

Or serve them using `index.php`:

`http://boringavatars.test/?variant={bauhaus|beam|marble|ring|text}&name=Jane Doe&size=120&color=#ffad08,#edd75a,#73b06f,#0c8f8f,#405059&title=true&square=false`

