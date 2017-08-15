## About Media entity

Media entity provides a 'base' entity for a media element. This is a very basic
entity which can reference to all kinds of media-objects (local files, YouTube
videos, tweets, CDN-files, ...). This entity only provides a relation between
Drupal (because it is an entity) and the resource. You can reference to this
entity within any other Drupal entity.

## About Media entity icon

This module provides SVG sprites/icons integration for Media entity (i.e. media type
provider plugin).

Features:
 - SVG sprite and SVG icon media types
 - Supports both local and CDN sprite sources
 - Sprite administration page to see the available icons, the ones created and the obsolete ones (in case of a source change)
 - Option to automatically create icons on a new sprite creation
 - Option to automatically create missing icons on a sprite update
 - Icon thumbnail can be generated as a PNG via SVG2PNG
 - Theme to render SVG icons based on an inline call with a use tag

## Configuration

Thumbnail width and SVG2PNG can be configured on the settings page: /admin/config/media/media_entity_icon  
This requires the "administer site configuration" permission.

Automated creation of icons at SVG creation/update can be set on the SVG sprite bundle: /admin/structure/media/manage/svg_sprite  
This requires the "administer media bundles" permission.

Related icons can be managed as a dedicated tab on the SVG media entity: /media/{media}/related_icons  
Accessing to the page requires the "access related icons" permission.  
Creating icons automatically or via the related icon page requires either "create media" or "autocreate icon" permission.

Sandbox page: https://www.drupal.org/sandbox/aerzas/2902225

Maintainers:
 - Nicolas Ricklin (@Aerzas) drupal.org/user/3180833
