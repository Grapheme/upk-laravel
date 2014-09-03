<?
namespace Intervention\Image;
use Closure;

class ImageWorks extends Image {

    /**
     * Resize current image based on given width/height
     *
     * Width and height are optional, the not given parameter is calculated
     * based on the given. The ratio boolean decides whether the resizing
     * should keep the image ratio. You can also pass along a boolean to
     * prevent the image from being upsized.
     *
     * @param integer $width  The target width for the image
     * @param integer $height The target height for the image
     * @param boolean $ratio  Determines if the image ratio should be preserved
     * @param boolean $upsize Determines whether the image can be upsized
     *
     * @return Image
     */
    public function resize_min($width = null, $height = null, $ratio = false, $upsize = true)
    {
        // catch legacy call
        if (is_array($width)) {
            $dimensions = $width;

            return $this->legacyResize($dimensions);
        }

        // Evaluate passed parameters.
        $width = isset($width) ? intval($width) : null;
        $height = $max_height = isset($height) ? intval($height) : null;
        $ratio = $ratio ? true : false;
        $upsize = $upsize ? true : false;

        // If the ratio needs to be kept.
        if ($ratio) {

            // If both width and hight have been passed along, the width and
            // height parameters are maximum values.
            if (! is_null($width) && ! is_null($height)) {

                // First, calculate the height.
                $height = intval($width / $this->width * $this->height);

                // If the height is too large, set it to the maximum
                // height and calculate the width.
                if ($height > $max_height) {

                    $height = $max_height;
                    $width = intval($height / $this->height * $this->width);
                }

            } elseif ($ratio && (! is_null($width) or ! is_null($height))) {

                // If only one of width or height has been provided.
                $width = is_null($width) ? intval($height / $this->height * $this->width) : $width;
                $height = is_null($height) ? intval($width / $this->width * $this->height) : $height;
            }
        }

file_put_contents('log.txt', $width . " / " . $height); die;

        // If the image can't be upsized, check if the given width and/or
        // height are too large.
        if (! $upsize) {
            // If the given width is larger then the image width,
            // then don't resize it.
            if (! is_null($width) && $width > $this->width) {
                $width = $this->width;

                // If ratio needs to be kept, height is recalculated.
                if ($ratio) {
                    $height = intval($width / $this->width * $this->height);
                }
            }

            // If the given height is larger then the image height,
            // then don't resize it.
            if (! is_null($height) && $height > $this->height) {
                $height = $this->height;

                // If ratio needs to be kept, width is recalculated.
                if ($ratio) {
                    $width = intval($height / $this->height * $this->width);
                }
            }
        }

        // If both the width and height haven't been passed along,
        // throw an exception.
        if (is_null($width) && is_null($height)) {

            throw new Exception\DimensionOutOfBoundsException('width or height needs to be defined');

        } elseif (is_null($width)) { // If only the width hasn't been set, keep the current width.

            $width = $this->width;

        } elseif (is_null($height)) { // If only the height hasn't been set, keep the current height.

            $height = $this->height;

        }

        // Create new image in new dimensions.
        return $this->modify(0, 0, 0, 0, $width, $height, $this->width, $this->height);
    }

}