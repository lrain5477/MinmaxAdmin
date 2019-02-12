<?php

namespace Minmax\Io\Interfaces;

use Illuminate\Http\Request;

/**
 * IoControllerInterface
 */
interface IoControllerInterface
{
    /**
     * @param  integer $id
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function example($id);

    /**
     * @param  Request $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request, $id);

    /**
     * @param  Request $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, $id);
}