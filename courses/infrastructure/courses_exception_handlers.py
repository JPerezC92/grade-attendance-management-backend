from typing import List

from fastapi import status, Request
from fastapi.responses import JSONResponse

from courses.domain.course import CourseNotFound
from shared_kernel.infrastructure.utils.register_exception_handlers import AddExceptionHandlerParams


def course_not_found_exception_handler(request: Request, exc: CourseNotFound) -> JSONResponse:
    return JSONResponse(
        status_code=status.HTTP_404_NOT_FOUND,
        content={
            "status_code": status.HTTP_404_NOT_FOUND,
            "message": exc.error_message()
        }
    )


courses_exception_handlers: List[AddExceptionHandlerParams] = [
    (CourseNotFound, course_not_found_exception_handler)
]
