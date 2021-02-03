# PrivateChest-PMMP

Lock your chest to make sure that no one can steals anything from you!

## How does it work?

When you click on a chest the lock menu opens, after locking it only you can reopen it or administrators with the given permissions in config

## Config

```yml
# CHEST MANAGER CONFIG

lock-chest-permission: null
chest-op-permission: private.chest.op
max-lock-chest: 5

# MESSAGES

format: "&7[&ePRIVATE CHEST&7]&8: &7"
chest-locked-message: This chest is locked!
successful-lock-chest: You have correctly lock the chest
successful-unlock-chest: You have correctly unlock the chest
break-locked-chest: You destroyed a locked chest!
limit-message: You have reached the limit of blocked chests!
chest-next-to: The chest next to it is not locked!

# FORMS

lock-form-title: "&l&eLOCK CHEST"
lock-form-description: "&7Click button below to lock chest"

lock-form-button-name: "&7&eLOCK"

# image types: url, path or null
lock-form-button-image-type: path

# if you have enabled image on button you have to specify the link or path to the file where you have image
# path images you can find here: https://github.com/ZtechNetwork/MCBVanillaResourcePack/tree/master/textures
# examples:

# url type: https://some-website-with-images.com/image.png
# path type: textures/blocks/barrier
lock-form-button-image-url: textures/items/diamond


# Same like in lock form
manage-form-title: "&l&eMANAGE CHEST"
manage-form-description: "&7Click button below to unlock chest"
manage-form-button-name: "&7&eUNLOCK"
manage-form-button-image-type: path
manage-form-button-image-url: textures/items/emerald
```
