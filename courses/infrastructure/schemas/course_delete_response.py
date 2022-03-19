from pydantic import BaseModel

from shared_kernel.infrastructure.response import Response


class DeleteRes(Response, BaseModel):
    pass
