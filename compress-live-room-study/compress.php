<?php
/**
 * Created by PhpStorm.
 * User: garrus
 * Date: 2017/11/5 0005
 * Time: 下午 10:09
 */
/**
 * 算法描述：
 * 1. scan word frequency/length. Replace the most frequent words
 * with un-use asc chars. But only words that contains at least 3 letters or above.
 * Remember the word-letter mapping.
 * 2. build huffman tree based on replaced content. Compress it.
 * 3. only sent encoded to client.
 */
