import { useEffect, useState } from "react";
import { ApiResponse } from "@components/Types";

export function useFetchAniversariantes() {
  const [dados, setDados] = useState<ApiResponse | null>(null);
  const [loading, setLoading] = useState(true);
  const apiKey = import.meta.env.VITE_API_SECRET_KEY;

  useEffect(() => {
    fetch("/v1/api/aniversariantes", {
      method: "GET",
      headers: {
        "Authorization": `Bearer ${apiKey}`,
        "Content-Type": "application/json"
      }
    })  
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
