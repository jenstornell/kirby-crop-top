# Kirby Crop Top

Version 0.1

Crop thumbs with top position.

**This is a really primitive plugin. It's only ment as a temporary fix for this issue:**

https://github.com/getkirby/toolkit/issues/99

I will not even add installation instructions for it. If you can't install it, wait for Kirby to catch up.

**Template/snippet**

```html
<?php
$thumb_url = $item->cropTop('image.png', array('width' => 380, 'height' => 190));
?>
<img src="<?php echo $thumb_url; ?>">
```

It takes filename (not an image object) and an array with width and height. The output is a thumbnail url. It saves it in `thumbs/crop-top/**/*`.

***Be aware! This object does not work exactly like the native thumb object has. It only works in this specific case.***