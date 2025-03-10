export interface Pessoa {
    nome: string;
    dataNascimento: string;
    cargo: string[];
    turma: string[];
  }
  
  export interface ApiResponse {
    Aniversariantes: "diario" | "mensal";
    dados: Pessoa[];
  }
  
  export async function fetchAniversariantes(): Promise<ApiResponse> {
    try {
      const response = await fetch("http://localhost:8000/v1/api/aniversariantes");
      if (!response.ok) throw new Error("Erro ao buscar dados");
      return await response.json();
    } catch (error) {
      console.error("Erro na API:", error);
      return { Aniversariantes: "mensal", dados: [] };
    }
  }
