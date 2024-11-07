<?php

function getImage($path) : String {
    if ($path != null &&  \Storage::disk('public')->exists($path)) {
        return asset('storage/' . $path);
    }
    return asset('/assets/images/category2.svg');
}