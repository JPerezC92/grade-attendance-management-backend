from typing import cast

import uvicorn
from asgiref.typing import ASGIApplication
from fastapi import FastAPI

from courses.infrastructure.routes import courses_router
from shared_kernel.infrastructure.database.connection import BaseDatabaseModel, engine

BaseDatabaseModel.metadata.create_all(bind=engine)

app: FastAPI = FastAPI()

app.include_router(courses_router)


@app.get("/")
def read_root():
    return {"Hello": "World"}


if __name__ == "__main__":
    uvicorn.run(cast(ASGIApplication, app), host="0.0.0.0", port=8000)
