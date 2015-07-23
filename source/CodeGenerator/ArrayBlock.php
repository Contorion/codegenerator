<?php

namespace CodeGenerator;

class ArrayBlock extends Block
{
    /** @var array */
    private $_value;

    /**
     * @param array $value
     */
    public function __construct(array $value = null)
    {
        $this->_value = (array)$value;
    }

    /**
     * @return string
     */
    public function dump()
    {
        $entries = [];
        $isAssociative = $this->isAssociative();
        foreach ($this->_value as $key => $value) {
            $line = '';
            if ($isAssociative) {
                $line .= $key . ' => ';
            }
            $value = new ValueBlock($value);
            $line .= $value->dump();
            $entries[] = $line;
        }
        $content = implode(', ', $entries);
        if (strlen($content) < 100) {
            return 'array(' . $content . ')';
        } else {
            $content = implode(",\n", $entries);

            return $this->_dumpLine(
                'array(',
                $this->_indent($content),
                ')'
            );
        }
    }

    public function isAssociative()
    {
        return (bool)count(array_filter(array_keys($this->_value), 'is_string'));
    }
}
