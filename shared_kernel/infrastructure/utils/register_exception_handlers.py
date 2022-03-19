from typing import List, Tuple, Union, Type, Callable, TypeVar

from fastapi import FastAPI

AddExceptionHandlerParams = TypeVar("AddExceptionHandlerParams", bound=Tuple[Union[int, Type[Exception]], Callable])


def register_exception_handlers(app: FastAPI, params: List[AddExceptionHandlerParams]) -> None:
    for p in params:
        app.add_exception_handler(*p)
