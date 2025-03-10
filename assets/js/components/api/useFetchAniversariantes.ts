// useFetchAniversariantes.ts
import { useEffect, useState } from "react";

type Cargo = {
  id: string;
  nome: string;
};

type Turma = {
  id: string;
  [key: string]: string;
};

type Pessoa = {
  nome: string;
  dataNascimento: string;
  cargo: Cargo;
  turma: Turma | null;
};

type ApiResponse = {
  Aniversariantes: string;
  dados: Record<string, Pessoa>;
};

export function useFetchAniversariantes() {
  const [dados, setDados] = useState<ApiResponse | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch("/v1/api/aniversariantes")
      .then((res) => res.json())
      .then((data: ApiResponse) => {
        if (data && data.dados) {
          setDados(data);
        }
        setLoading(false);
      })
      .catch((error) => {
        console.error("Erro ao buscar dados:", error);
        setLoading(false);
      });
  }, []);

  return { dados, loading };
}
