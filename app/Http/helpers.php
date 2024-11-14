<?php

function getImage($path, $type = 'category') : String {
    if ($path != null &&  \Storage::disk('public')->exists($path)) {
        return asset('storage/' . $path);
    }
    
    return asset('/assets/images/category2.svg');
}