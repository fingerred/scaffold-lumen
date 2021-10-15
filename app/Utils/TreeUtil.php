<?php declare(strict_types=1);

/**
 * Create by Red.jiang in 9/14/21 at 3:56 PM
 *
 * Email redmadfinger@gmail.com
 */

namespace App\Utils;

class TreeUtil
{
    /**
     * 获得tree
     *
     * @param array $data
     * @param string $pidKey
     * @param string $idKey
     * @param string $childName
     *
     * @return array
     */
    public static function listToTree(array $data, $pidKey = 'parentId', $idKey = 'id', $childName = 'children')
    {
        $tree = [];
        foreach ($data as $row) {
            $tree[$row[$idKey]] = $row;
            $tree[$row[$idKey]][$childName] = [];
        }

        foreach ($tree as $key => $item) {
            if ($item[$pidKey] != 0) {
                $tree[$item[$pidKey]][$childName][] = &$tree[$key];
            }
        }

        foreach ($tree as $key => $row) {
            if ($row[$pidKey] != 0) {
                unset($tree[$key]);
            }
        }

        $tree = array_values($tree);
        return self::markLeaf($tree, $childName);
    }

    /**
     * 标记叶子
     *
     * @param array $tree
     * @param string $childName
     *
     * @return array
     */
    private static function markLeaf(array &$tree, $childName = 'children')
    {
        foreach ($tree as $key => &$item) {
            if (empty($item[$childName])) {
                $tree[$key]['leaf'] = true;
            } else {
                self::markLeaf($item[$childName], $childName);
            }
        }

        return $tree;
    }

    public static function leafIds(array &$ids, array $tree, $childName = 'children')
    {
        foreach ($tree as $key => &$item) {
            if (empty($item[$childName])) {
                $ids[] = $item['id'];
            } else {
                self::leafIds($ids, $item[$childName], $childName);
            }
        }

        return $ids;
    }

    public static function childrenIds(array &$ids, array $tree, $childName = 'children')
    {
        foreach ($tree as $key => &$item) {
            $ids[] = $item['id'];

            if (!empty($item[$childName])) {
                self::childrenIds($ids, $item[$childName], $childName);
            }
        }

        return $ids;
    }
}
