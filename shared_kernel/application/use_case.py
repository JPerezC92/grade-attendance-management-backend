from abc import ABC, abstractmethod
from typing import Generic, Any, TypeVar

Output = TypeVar('Output')


class UseCase(Generic[Output], ABC):

    @abstractmethod
    def execute(self, **kwargs: Any) -> Output:
        pass
