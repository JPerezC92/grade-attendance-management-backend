from pydantic import BaseModel

from shared_kernel.infrastructure.response import Response


class Message(Response, BaseModel):
    message: str
